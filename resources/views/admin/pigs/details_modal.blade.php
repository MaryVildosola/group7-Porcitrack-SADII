<div class="pig-details-hud text-left">
    @php $pendingAlert = $pig->activities->where('is_critical_alert', true)->whereNull('acknowledged_at')->first(); @endphp
    @if($pendingAlert)
    <div style="background: #fef2f2; border: 2px solid #ef4444; padding: 20px; border-radius: 20px; margin-bottom: 24px; animation: pulse-border 2s infinite;">
        <div style="display: flex; gap: 16px; align-items: flex-start;">
            <div style="width: 48px; height: 48px; background: #fee2e2; color: #ef4444; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;">
                <i class='bx bxs-error-alt animate-bounce'></i>
            </div>
            <div style="flex: 1;">
                <h3 style="font-size: 0.9rem; font-weight: 900; color: #991b1b; margin: 0; text-transform: uppercase;">Unresolved Critical Alert</h3>
                <p style="font-size: 0.8rem; color: #b91c1c; margin: 4px 0 12px;">Worker reported: <span style="font-weight: 700;">"{{ $pendingAlert->details }}"</span></p>
                
                <div style="background: rgba(153, 27, 27, 0.05); padding: 10px; border-radius: 12px; margin-bottom: 12px; border: 1px dashed rgba(153, 27, 27, 0.2);">
                    <p style="font-size: 0.7rem; color: #991b1b; margin: 0; font-weight: 700;">Current Physical Status: <span style="color: #64748b; font-weight: 400;">{{ $pig->health_status }} · Feeding: {{ $pig->feeding_status }}</span></p>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button onclick="acknowledgeAlert({{ $pendingAlert->id }}, '{{ $pig->health_status }}', '{{ $pig->feeding_status }}', {{ json_encode($pens->map(fn($p) => ['id' => $p->id, 'name' => $p->name])) }}, {{ $pig->pen_id }})" id="ack-btn-{{ $pendingAlert->id }}" style="background: #ef4444; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 0.75rem; font-weight: 800; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                        <i class='bx bx-check-shield'></i> Acknowledge & Update Care
                    </button>
                    <button onclick="window.quickAssignTask(event, {{ $pig->id }}, '{{ $pig->tag }}', {{ $pig->pen_id }})" style="background: #fff; color: #ef4444; border: 1px solid #ef4444; padding: 8px 16px; border-radius: 8px; font-size: 0.75rem; font-weight: 800; cursor: pointer;">
                        Add Monitor Task
                    </button>
                </div>
            </div>
        </div>
    </div>
    <style>
        @keyframes pulse-border {
            0% { border-color: #ef4444; box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            70% { border-color: #f87171; box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
            100% { border-color: #ef4444; box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
    </style>
    @endif

    <form id="admin-edit-pig-form">
        @csrf
        <!-- Header with Background -->
        <div style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 32px; border-radius: 24px; color: white; margin-bottom: 24px; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(15, 23, 42, 0.2);">
            <div style="position: absolute; top: -20px; right: -20px; width: 120px; height: 120px; background: rgba(34, 197, 94, 0.15); border-radius: 50%; blur: 40px;"></div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; position: relative; z-index: 1;">
                <div style="flex: 1;">
                    <p style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #94a3b8; margin-bottom: 8px;">Individual Record</p>
                    <h2 class="view-mode" style="font-size: 2.8rem; font-weight: 900; letter-spacing: -0.05em; margin: 0; color: #ffffff;">#{{ $pig->tag }}</h2>
                    <div class="edit-mode" style="display:none; margin-bottom: 12px;">
                        <label style="display:block; font-size: 11px; font-weight: 800; color: #94a3b8; margin-bottom: 6px; text-transform: uppercase;">Ear Tag ID</label>
                        <input type="text" name="tag" value="{{ $pig->tag }}" style="font-size: 1.8rem; font-weight: 900; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.2); color: white; border-radius: 14px; padding: 10px 16px; width: 85%; outline: none; transition: border-color 0.2s;">
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: 16px;">
                        @php
                            $healthColor = match($pig->health_status) {
                                'Healthy' => '#22c55e',
                                'Warning' => '#f59e0b',
                                'Sick' => '#ef4444',
                                default => '#64748b'
                            };
                        @endphp
                        <span class="view-mode" style="background: {{ $healthColor }}; color: #ffffff; padding: 6px 16px; border-radius: 99px; font-size: 0.75rem; font-weight: 800; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">{{ $pig->health_status }}</span>
                        <div class="edit-mode" style="display:none;">
                            <select name="health_status" style="background: {{ $healthColor }}; color: #ffffff; border: none; padding: 6px 16px; border-radius: 99px; font-size: 0.75rem; font-weight: 800; cursor: pointer; outline: none; appearance: none; -webkit-appearance: none; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                                <option value="Healthy" {{ $pig->health_status == 'Healthy' ? 'selected' : '' }}>Healthy</option>
                                <option value="Warning" {{ $pig->health_status == 'Warning' ? 'selected' : '' }}>Warning</option>
                                <option value="Sick" {{ $pig->health_status == 'Sick' ? 'selected' : '' }}>Sick</option>
                            </select>
                        </div>

                        <span class="view-mode" style="background: rgba(255, 255, 255, 0.15); color: #f8fafc; padding: 6px 16px; border-radius: 99px; font-size: 0.75rem; font-weight: 800; backdrop-filter: blur(4px);">{{ $pig->breed ?? 'Standard' }}</span>
                        <div class="edit-mode" style="display:none;">
                            <input type="text" name="breed" value="{{ $pig->breed }}" placeholder="Breed" style="background: rgba(255, 255, 255, 0.15); color: #f8fafc; border: 1.5px solid rgba(255,255,255,0.1); padding: 6px 16px; border-radius: 99px; font-size: 0.75rem; font-weight: 800; outline: none; width: 120px;">
                        </div>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 14px;">
                    <button type="button" id="edit-pig-toggle-btn" onclick="togglePigEdit()" style="background: rgba(255,255,255,0.1); color: #ffffff; border: 1.5px solid rgba(255,255,255,0.2); padding: 10px 20px; border-radius: 14px; font-size: 0.8rem; font-weight: 800; cursor: pointer; backdrop-filter: blur(10px); transition: all 0.2s;">
                        <i class='bx bx-edit-alt'></i> Edit Details
                    </button>
                    <!-- Quick Assign Task Trigger -->
                    <button type="button" class="view-mode" onclick="window.quickAssignTask(event, {{ $pig->id }}, '{{ $pig->tag }}', {{ $pig->pen_id }})" data-workers="{{ json_encode($workers) }}" style="background: #22c55e; color: #ffffff; border: none; padding: 10px 18px; border-radius: 14px; font-size: 0.8rem; font-weight: 800; display: flex; align-items: center; gap: 8px; cursor: pointer; box-shadow: 0 8px 16px rgba(34, 197, 94, 0.3); transition: transform 0.2s;">
                        <i class='bx bx-task'></i> Quick Assign
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 32px;">
            <div style="background: #ffffff; padding: 24px; border-radius: 24px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                <p style="font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.05em;">Weight</p>
                <div class="view-mode" style="display: flex; align-items: baseline; gap: 6px;">
                    <span style="font-size: 1.8rem; font-weight: 900; color: #1e293b;">{{ $pig->weight ?: '0' }}</span>
                    <span style="font-size: 0.85rem; font-weight: 700; color: #94a3b8;">KG</span>
                </div>
                <div class="edit-mode" style="display:none;">
                    <input type="number" step="0.01" name="weight" value="{{ $pig->weight }}" style="width: 100%; font-size: 1.4rem; font-weight: 800; border: 2px solid #f1f5f9; border-radius: 12px; padding: 10px; color: #1e293b; outline: none; background: #f8fafc;">
                </div>
            </div>
            <div style="background: #ffffff; padding: 24px; border-radius: 24px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                <p class="view-mode" style="font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.05em;">Age</p>
                <p class="edit-mode" style="display:none; font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.05em;">Birth Date</p>
                <div class="view-mode" style="display: flex; align-items: baseline; gap: 6px;">
                    <span style="font-size: 1.8rem; font-weight: 900; color: #1e293b;">{{ round($pig->age_in_days / 7, 1) }}</span>
                    <span style="font-size: 0.85rem; font-weight: 700; color: #94a3b8;">WEEKS</span>
                </div>
                <div class="edit-mode" style="display:none;">
                    <input type="date" name="birth_date" value="{{ $pig->birth_date ? $pig->birth_date->format('Y-m-d') : '' }}" style="width: 100%; font-size: 1rem; font-weight: 800; border: 2px solid #f1f5f9; border-radius: 12px; padding: 10px; color: #1e293b; outline: none; background: #f8fafc;">
                </div>
            </div>
            <div style="background: #ffffff; padding: 24px; border-radius: 24px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                <p style="font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.05em;">BCS</p>
                <div class="view-mode" style="display: flex; align-items: baseline; gap: 6px;">
                    <span style="font-size: 1.8rem; font-weight: 900; color: #1e293b;">{{ $pig->bcs_score ?: '3' }}</span>
                    <span style="font-size: 0.85rem; font-weight: 700; color: #94a3b8;">/ 5</span>
                </div>
                <div class="edit-mode" style="display:none;">
                    <select name="bcs_score" style="width: 100%; font-size: 1.4rem; font-weight: 800; border: 2px solid #f1f5f9; border-radius: 12px; padding: 10px; color: #1e293b; outline: none; background: #f8fafc; cursor: pointer;">
                        @for($i=1; $i<=5; $i++)
                            <option value="{{ $i }}" {{ ($pig->bcs_score ?: 3) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <!-- Mixture & Feeding Section -->
        <div style="margin-bottom: 32px;">
            <h3 style="font-size: 0.9rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; color: #1e293b; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <div style="width: 32px; height: 32px; background: #dcfce7; color: #22c55e; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class='bx bx-bowl-hot'></i>
                </div>
                Feeding & Mixture
            </h3>
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 28px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);">
                <div style="display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 0.9rem; align-items: center;">
                    <span style="color: #475569; font-weight: 600;">Feeding Activity:</span>
                    <span class="view-mode" style="font-weight: 800; color: #1e293b;">{{ $pig->feeding_status ?: 'Normal' }}</span>
                    <div class="edit-mode" style="display:none;">
                        <select name="feeding_status" style="font-size: 0.9rem; font-weight: 800; border: 2px solid #f1f5f9; border-radius: 10px; padding: 6px 14px; color: #1e293b; outline: none; background: #f8fafc; cursor: pointer;">
                            <option value="Normal" {{ ($pig->feeding_status ?: 'Normal') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Active" {{ $pig->feeding_status == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Poor" {{ $pig->feeding_status == 'Poor' ? 'selected' : '' }}>Poor</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 0.9rem; align-items: center;">
                    <span style="color: #475569; font-weight: 600;">Target Market Weight:</span>
                    <span class="view-mode" style="font-weight: 800; color: #1e293b;">{{ $pig->target_weight ?: '0' }} KG</span>
                    <div class="edit-mode" style="display:none;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <input type="number" step="0.01" name="target_weight" value="{{ $pig->target_weight }}" style="width: 100px; font-size: 0.9rem; font-weight: 800; border: 2px solid #f1f5f9; border-radius: 10px; padding: 6px 12px; color: #1e293b; outline: none; background: #f8fafc;">
                            <span style="font-size: 0.8rem; font-weight: 700; color: #94a3b8;">KG</span>
                        </div>
                    </div>
                </div>
                <div class="edit-mode" style="display:none; margin-top: 16px; border-top: 1px dashed #e2e8f0; padding-top: 16px;">
                    <label style="display:block; font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 10px; letter-spacing: 0.05em;">Admin Remarks / Clinical Notes</label>
                    <textarea name="remarks" style="width: 100%; border: 2px solid #f1f5f9; border-radius: 16px; padding: 16px; font-size: 0.9rem; height: 100px; outline: none; resize: none; background: #f8fafc; color: #1e293b;" placeholder="Add specific observation notes for workers or vet staff...">{{ $pig->remarks }}</textarea>
                </div>
                <div class="view-mode" style="padding-top: 16px; border-top: 1px dashed #e2e8f0; font-size: 0.85rem; color: #475569;">
                    <p style="font-weight: 800; color: #1e293b; margin-bottom: 10px;">Recommended Mixture Component:</p>
                    @php
                        $mix = match($pig->growth_stage) {
                            'Piglet' => 'Pre-starter high protein crumbles',
                            'Starter' => '60% Corn, 25% Soya, 5% Fishmeal, 10% Rice Bran',
                            'Grower' => '65% Corn, 20% Soya, 15% Rice Bran + Minerals',
                            'Finisher' => '70% Corn, 10% Soya, 20% Rice Bran',
                            default => 'Standard Ration'
                        };
                    @endphp
                    <div style="background: #f8fafc; padding: 14px; border-radius: 14px; color: #334155; font-family: 'Outfit', sans-serif; font-weight: 600; border: 1px solid #f1f5f9;">
                        <i class='bx bx-info-circle' style="color: #22c55e; margin-right: 6px;"></i> {{ $mix }}
                    </div>
                </div>
            </div>
        </div>

        <div id="edit-actions-hud" class="edit-mode" style="display: none; gap: 12px; margin-top: 24px; align-items: center; justify-content: stretch;">
            <button type="button" onclick="saveAdminPigChanges({{ $pig->id }})" style="flex: 2; background: #22c55e; color: white; border: none; padding: 16px; border-radius: 16px; font-weight: 800; cursor: pointer; box-shadow: 0 10px 20px rgba(34, 197, 94, 0.2);">Save Changes</button>
            <button type="button" onclick="togglePigEdit()" style="flex: 1; background: #f1f5f9; color: #64748b; border: none; padding: 16px; border-radius: 16px; font-weight: 700; cursor: pointer;">Cancel</button>
        </div>
    </form>

    <!-- Tabs for History -->
    <div class="view-mode" style="display: flex; gap: 8px; margin-bottom: 20px; padding: 6px; background: #e2e8f0; border-radius: 14px; width: fit-content; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);">
        <button class="mini-tab-btn active" onclick="switchMiniTab(event, 'th-activities')" style="padding: 8px 20px; border-radius: 10px; border: none; background: #ffffff; font-size: 0.75rem; font-weight: 800; cursor: pointer; color: #1e293b; box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: all 0.2s;">Activities</button>
        <button class="mini-tab-btn" onclick="switchMiniTab(event, 'th-tasks')" style="padding: 8px 20px; border-radius: 10px; border: none; background: transparent; font-size: 0.75rem; font-weight: 800; cursor: pointer; color: #64748b; transition: all 0.2s;">Worker Tasks</button>
    </div>

    <!-- Tab Contents -->
    <div id="th-activities" class="mini-tab-content view-mode" style="max-height: 280px; overflow-y: auto; padding-right: 10px;">
        @forelse($pig->activities as $activity)
        <div style="display: flex; gap: 16px; padding: 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 20px; margin-bottom: 12px; align-items: flex-start; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div style="width: 40px; height: 40px; border-radius: 12px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; border: 1px solid #dcfce7;">
                <i class='bx {{ $activity->type === "Medical" ? "bx-plus-medical" : "bx-check" }}'></i>
            </div>
            <div style="flex: 1;">
                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                    <h4 style="font-size: 0.85rem; font-weight: 800; color: #1e293b; margin: 0;">{{ $activity->action }}</h4>
                    <span style="font-size: 0.65rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">{{ $activity->created_at->diffForHumans() }}</span>
                </div>
                <p style="font-size: 0.8rem; color: #475569; margin-top: 4px; line-height: 1.4;">{{ $activity->details ?: 'Recorded by worker' }}</p>
                
                @if($activity->admin_response)
                <div style="margin-top: 12px; padding: 12px; background: #f8fafc; border-radius: 14px; border: 1px solid #e2e8f0;">
                    <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 6px;">
                        <i class='bx bxs-badge-check' style="color: #22c55e;"></i>
                        <p style="font-size: 0.65rem; font-weight: 900; color: #475569; margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Admin Response</p>
                    </div>
                    <p style="font-size: 0.8rem; color: #1e293b; margin: 0; font-weight: 500;">{{ $activity->admin_response }}</p>
                    <div style="margin-top: 8px; display: flex; gap: 10px;">
                        <span style="font-size: 0.65rem; color: #166534; font-weight: 800; background: #dcfce7; padding: 2px 8px; border-radius: 6px;">Health: {{ $activity->new_health_status }}</span>
                        <span style="font-size: 0.65rem; color: #166534; font-weight: 800; background: #dcfce7; padding: 2px 8px; border-radius: 6px;">Feeding: {{ $activity->new_feeding_status }}</span>
                    </div>
                </div>
                @endif

                <div style="font-size: 0.7rem; color: #94a3b8; margin-top: 10px; display: flex; align-items: center; gap: 6px; font-weight: 600;">
                    <i class='bx bx-user-circle'></i> {{ $activity->user->name ?? 'System' }}
                </div>
            </div>
        </div>
        @empty
        <div style="text-align: center; padding: 40px 20px; background: #ffffff; border-radius: 24px; border: 1px dashed #cbd5e1;">
            <i class='bx bx-history' style="font-size: 2rem; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
            <p style="font-size: 0.85rem; color: #94a3b8; font-weight: 600; margin: 0;">No activities recorded yet.</p>
        </div>
        @endforelse
    </div>

    <div id="th-tasks" class="mini-tab-content view-mode" style="display: none; max-height: 280px; overflow-y: auto; padding-right: 10px;">
        @forelse($pig->tasks as $task)
        <div style="padding: 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 20px; margin-bottom: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                <h4 style="font-size: 0.85rem; font-weight: 800; color: #1e293b; margin: 0;">{{ $task->title }}</h4>
                <span style="padding: 4px 12px; border-radius: 99px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; background: {{ $task->status === 'completed' ? '#dcfce7' : '#fef9c3' }}; color: {{ $task->status === 'completed' ? '#166534' : '#854d0e' }}; border: 1px solid {{ $task->status === 'completed' ? '#bbf7d0' : '#fef08a' }};">
                    {{ $task->status }}
                </span>
            </div>
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 4px; line-height: 1.4;">{{ $task->description }}</p>
            <div style="margin-top: 12px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 10px;">
                <span style="font-size: 0.7rem; color: #94a3b8; font-weight: 600;"><i class='bx bx-user'></i> {{ $task->assignee->name ?? 'Unassigned' }}</span>
                <span style="font-size: 0.7rem; color: #94a3b8; font-weight: 600;"><i class='bx bx-calendar'></i> {{ $task->completed_at ? $task->completed_at->format('M d, Y') : 'Pending' }}</span>
            </div>
        </div>
        @empty
        <div style="text-align: center; padding: 40px 20px; background: #ffffff; border-radius: 24px; border: 1px dashed #cbd5e1;">
            <i class='bx bx-list-check' style="font-size: 2rem; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
            <p style="font-size: 0.85rem; color: #94a3b8; font-weight: 600; margin: 0;">No tasks assigned to this animal.</p>
        </div>
        @endforelse
    </div>

</div>

